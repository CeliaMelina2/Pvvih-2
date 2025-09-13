use Illuminate\Auth\AuthenticationException;

protected function unauthenticated($request, AuthenticationException $exception)
{
    return $request->expectsJson()
        ? response()->json(['message' => $exception->getMessage()], 401)
        : redirect()->guest(route('patient.login')); // 🔴 on force la redirection vers patient.login
}
