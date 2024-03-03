import { FormEvent } from 'react';
import { cookies } from 'next/headers';

export function LoginForm() {
  function UpdateLoginForm(authenticated: boolean) {
    if (authenticated == false) {
      document.getElementById('username')?.classList.add('is-invalid');
      document.getElementById('password')?.classList.add('is-invalid');
    } else {
      document.getElementById('username')?.classList.remove('is-invalid');
      document.getElementById('password')?.classList.remove('is-invalid');
    }
  }

  function ValidateLogin(e: FormEvent<HTMLFormElement>) {
    e.preventDefault();
    
    const data = new FormData(e.currentTarget);
    
    const username = data.get('username');
    const password = data.get('password');
    
    var authenticated = false;
    
    if (username && password) {
      fetch(
        process.env.NEXT_PUBLIC_API_URL + '/auth.php',
        { method: "POST", } //headers: {"user": username.toString(), "password": password.toString()} }
      ).then((response) => {
        authenticated = response.status == 200;
        var token = response.body?["token"].toString() : "";
        cookies().set('token', token, { secure: true });
      }).catch((error) => {
        console.log(error);
      }).finally(() => {
        UpdateLoginForm(authenticated);
      });
    }
  }

  return (
    <section>
      <div className="container my-5">
        <h1>Freemind</h1>
          <p>
            To proceed please login using your credentials:
          </p>
      </div>
      <div className="container">
        <form method="post" onSubmit={ValidateLogin} className='needs-validation'>
          <div className='input-group'>
            <input autoFocus type="text" className="form-control" id="username" placeholder="Username" name="username" />
            <input type="password" className="form-control" id="password" placeholder="Password" name="password" />
            <button type="submit" className="btn btn-primary">Login</button>
          </div>
        </form>
      </div>
    </section>
  );
}