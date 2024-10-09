<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://unpkg.com/vue@3"></script>
    <style>
        body {
            height: 100%;
            }

            .form-signin {
            max-width: 330px;
            padding: 1rem;
            }

            .form-signin .form-floating:focus-within {
            z-index: 2;
            }

            .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
            }

            .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
            }
    </style>
    <title>Sign In</title>
</head>
<body class="d-flex align-items-center py-4 bg-body-tertiary">
    <main class="form-signin w-100 m-auto">
        <form action="{{ route('register.post') }}" method="POST">
					@csrf
          <h1 class="h3 mb-3 fw-normal">Registrarse</h1>

					<div class="form-floating">
						@error('name')
                <div style="color: red;">{{ $message }}</div>
            @enderror
						<input type="text" class="form-control" value="{{ old('name') }}" id="name" name="name" placeholder="Juan Perez">
						<label for="name">Nombre</label>
					</div>
          
					<div class="form-floating">
						@error('email')
							<div style="color: red;">{{ $message }}</div>
						@enderror
						<input type="email" class="form-control" value="{{ old('email') }}" id="floatingInput" name="email" placeholder="name@example.com">
						<label for="floatingInput">Email address</label>
					</div>

          <div class="form-floating">
						@error('password')
						<div style="color: red;">{{ $message }}</div>
						@enderror
            <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password">
            <label for="floatingPassword">Password</label>
          </div>
          <div class="form-floating">
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Password">
            <label for="password_confirmation">Confirmar Contraseña</label>
          </div>
					
          <button class="btn btn-primary w-100 py-2" type="submit">Registrarme</button>
        </form>
      </main>
</body>
</html>