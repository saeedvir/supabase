<?php

namespace Saeedvir\Supabase\Examples;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Saeedvir\Supabase\Facades\Supabase;

class SupabaseExampleController extends Controller
{
    /**
     * Example of using the Supabase Database service
     */
    public function getUsers()
    {
        try {
            $users = Supabase::db()->select('users', '*', ['active' => true], [
                'limit' => 10,
                'order' => 'created_at.desc'
            ]);

            if (isset($users['error'])) {
                return response()->json(['error' => $users['message']], 500);
            }

            return response()->json($users);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Example of using the Supabase Auth service
     */
    public function authenticate(Request $request)
    {
        try {
            $result = Supabase::auth()->signIn($request->email, $request->password);

            if (isset($result['error'])) {
                return response()->json(['error' => $result['message']], 401);
            }

            return response()->json([
                'message' => 'Authentication successful',
                'user' => $result['user'],
                'session' => $result['session']
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Example of using the Supabase Storage service
     */
    public function uploadAvatar(Request $request)
    {
        try {
            if (!$request->hasFile('avatar')) {
                return response()->json(['error' => 'No file uploaded'], 400);
            }

            $file = $request->file('avatar');
            $path = $file->store('temp');

            // Get user ID (in a real app, you would get this from the authenticated user)
            $userId = 1; // Example user ID

            $result = Supabase::storage()->upload(
                'avatars',
                $userId . '.png',
                storage_path('app/' . $path),
                ['upsert' => true]
            );

            // Clean up temporary file
            unlink(storage_path('app/' . $path));

            if (isset($result['error'])) {
                return response()->json(['error' => $result['message']], 500);
            }

            return response()->json([
                'message' => 'Upload successful',
                'data' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Example of getting Supabase connection info
     */
    public function info()
    {
        return response()->json(Supabase::info());
    }
}