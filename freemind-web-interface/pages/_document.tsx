import { Html, Head, Main, NextScript } from 'next/document'
 
export default function Document() {
  return (
    <Html>
      <Head>
        <meta httpEquiv="content-type" content="text/html; charset=UTF-8"/>
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
        <meta content="#cd202c" data-react-helmet="true" name="theme-color"/>
        <meta name="robots" content="index follow"/>
        <meta name="googlebot" content="index follow"/>
        <link media="screen, print"/>
        <link rel="shortcut icon" type="image/png" href="./img/logo.png"/>
        <link rel="icon" type="image/png" href="/img/logo.png"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
      </Head>
      <body>
        <Main />
        <NextScript />
      </body>
    </Html>
  )
}