<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        try {
            $request->authenticate();
            $request->session()->regenerate();

            if ($request->user()->usertype == 'admin') {
                return redirect('admin/dashboard');
            }

            return redirect()->intended(route('dashboard'));
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->getMessages();
            return back()->withErrors($errors)->withInput($request->only('phone'));
        } catch (\Exception $e) {
            return back()->withErrors([
                'phone' => 'The provided credentials do not match our records.',
            ])->withInput($request->only('phone'));
        }
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
