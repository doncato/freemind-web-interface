import Head from 'next/head'

function Customhead() {
  return (
    <Head>
      <title>Freemind</title>
      <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
      <meta name="author" content="doncato"/>
      <meta name="description" content="Freemind is an application to organize most deadlines and todos"/>
      <meta name="keywords" content="doncato,freemind,calendar,management,todo,app,application"/>
      <meta name="color-scheme" content="bright"/>
      <link rel="author" href=".humans.txt"/>

      <meta content="Freemind" property="og:title"/>
      <meta content="Freemind is an application to organize most deadlines and todos" property="og:description"/>
      <meta content="Freemind - Management App" property="og:site_name"/>
      <meta content="website" property="og:type"/>
      <meta content="." property="og:url"/>
      <meta content="./img/logo.png" property="og:image"/>
      <meta content="#900000" data-react-helmet="true" name="theme-color"/>
      <meta name="robots" content="index follow"/>
      <meta name="googlebot" content="index follow"/>
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <link media="screen, print"/>
      <link rel="shortcut icon" type="image/png" href="./img/logo.png"/>
      <link rel="icon" type="image/png" href="/img/logo.png"/>
    </Head>
  );
}

export default function Home() {
  return (
    <section>
        <Customhead></Customhead>

        <div className="container my-5">
            <h1>Freemind</h1>
            <p>
                To proceed please enter your credentials:
            </p>
        </div>
        <div className="container">
            <form action="./action/login.php" method='post' className='needs-validation'>
                <div className='input-group'>
                    <input type="text" className="form-control <?php echo $invalid; ?>" id="username" placeholder="Username" name="username" />
                    <input type="password" className="form-control <?php echo $invalid; ?>" id="password" placeholder="Password" name="password" />
                    <button type="submit" className="btn btn-primary">Login</button>
                </div>
            </form>
        </div>
    </section>
  );
}