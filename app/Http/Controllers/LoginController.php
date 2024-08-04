<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Hash;
use Session;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    function index()
    {
        return view("login");
    }

    function registration()
    {
        $UserRoles = UserRole::orderBy("id", "desc")->get();
        return view("registration", compact("UserRoles"));
    }

    function validate_registration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required|min:6",
            "confirmPassword" => "required|same:password|min:6",
        ]);

        if ($validator->fails()) {
            session()->flash("password", $request->password);
            session()->flash("confirmPassword", $request->confirmPassword);

            // Redirect back with errors and input except passwords
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();

        User::create([
            "name" => $data["name"],
            "email" => $data["email"],
            "password" => Hash::make($data["password"]),
            "user_role" => $data["userRole"],
        ]);

        return redirect("login")->with(
            "success",
            "Registration Completed, now you can login"
        );
    }

    function dashboard()
    {
        if (Auth::check()) {
            return view("dashboard");
        }

        return redirect("login")->with(
            "success",
            "you are not allowed to access"
        );
    }

    function logout()
    {
        Session::flush();
        Auth::logout();

        Session::regenerate();

        return Redirect("login");
    }

    function profile()
    {
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $detail = [
                "userId" => Auth::user()->id,
                "name" => Auth::user()->name,
                "email" => Auth::user()->email,
            ];
            return view("profile", ["detail" => $detail]);
        }

        return redirect("login")->with(
            "success",
            "you are not allowed to access"
        );
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            "name" => "required|string|max:225",
            "email" => [
                "required",
                "email",
                Rule::unique("users")->ignore($user->id),
            ],
        ]);

        $user->name = $request->input("name");
        $user->email = $request->input("email");

        $user->save();

        return response()->json(["success" => "Profile updated successfully."]);
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            "password" => "required|min:6",
            "confirmPassword" => "required|same:password|min:6",
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json(
                    ["errors" => $validator->errors()],
                    422
                );
            }

            session()->flash("password", $request->password);
            session()->flash("confirmPassword", $request->confirmPassword);

            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->password = Hash::make($request->input("password"));

        $user->save();

        return response()->json(["success" => "Profile updated successfully."]);
    }

    public function userList()
    {
        $users = DB::table("users")
            ->join("user_roles", "user_roles.id", "=", "users.user_role")
            ->select("users.*", "user_roles.user_type")
            ->paginate(10);
        return view("userList", compact("users"));
    }

    public function validate_login(Request $request)
    {
        $request->validate([
            "email" => "required",
            "password" => "required",
        ]);

        $credentials = $request->only("email", "password");
        $remember = $request->has("remember");

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
            if ($user->hasRole("Super Admin")) {
                return redirect()->route("super-admin.dashboard");
            } elseif ($user->hasRole("Admin")) {
                return redirect()->route("admin.dashboard");
            } elseif ($user->hasRole("Editor")) {
                return redirect()->route("editor.dashboard");
            } elseif ($user->hasRole("Member")) {
                return redirect()->route("member.dashboard");
            }
        }

        return redirect("login")->with("error", "Login details are not valid");
    }

    public function superAdminDashboard()
    {
        $user = Auth::user();
        return view("superAdmin", compact("user"));
    }

    public function adminDashboard()
    {
        $user = Auth::user();
        return view("admin", compact("user"));
    }

    public function editorDashboard()
    {
        $user = Auth::user();
        return view("editor", compact("user"));
    }

    public function memberDashboard()
    {
        $user = Auth::user();
        return view("member", compact("user"));
    }

    public function loginAs(Request $request)
    {
        $request->validate([
            "user_id" => "required|exists:users,id",
        ]);

        if (Auth::user()->user_role !== "Super Admin") {
            if (Auth::user()->user_role == "Admin") {
                return redirect()->route("admin.dashboard");
            } elseif (Auth::user()->user_role == "Editor") {
                return redirect()->route("editor.dashboard");
            } elseif (Auth::user()->user_role == "Member") {
                return redirect()->route("member.dashboard");
            }
        }

        $user = User::findOrFail($request->user_id);

        Auth::logout();

        Auth::login($user);

        // Redirect to the user's dashboard or home page
        if ($user->user_role == 1) {
            return redirect()->route("super-admin.dashboard");
        } elseif ($user->user_role == 2) {
            return redirect()->route("admin.dashboard");
        } elseif ($user->user_role == 3) {
            return redirect()->route("editor.dashboard");
        } elseif ($user->user_role == 4) {
            return redirect()->route("member.dashboard");
        } else {
            return redirect()->route("login");
        }
    }
}