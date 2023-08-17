<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $authUserPermission = auth()->user()->getRoleNames();
        if($authUserPermission->count()) {

            $users = User::all();

            return response()->json([
                'status' => true,
                'message' => 'Users listing',
                'data' => $users
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Forbidden Error'
            ], 403);
        }
    }
    /**
     * @param User $user
     * @param ProfileUpdateRequest $request
     * @return JsonResponse
     */
    public function update(User $user, ProfileUpdateRequest $request): JsonResponse
    {
        $authUserPermission = auth()->user()->getRoleNames();
        if($authUserPermission->toArray() === $user->getRoleNames()->toArray() || $authUserPermission->contains('admin') || ($authUserPermission->contains('manager') && $user->first()->getRoleNames()->contains('admin'))) {

            $user->update($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Profile update successfully!'
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Forbidden Error'
            ], 403);
        }
    }

    public function destroy(User $user): JsonResponse
    {
        $authUserPermission = auth()->user()->getRoleNames();
        if($authUserPermission->toArray() === $user->getRoleNames()->toArray() || $authUserPermission->contains('admin') || ($authUserPermission->contains('manager') && $user->getRoleNames()->contains('admin'))) {

            $user->delete();

            return response()->json([
                'status' => true,
                'message' => 'Deleted successfully!'
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Forbidden Error'
            ], 403);
        }
    }
}
