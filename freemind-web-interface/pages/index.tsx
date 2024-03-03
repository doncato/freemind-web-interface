import Head from 'next/head'
import { LoginForm } from './login'
import { Dashboard } from './dashboard'

import dotenv from "dotenv";
import { cookies } from 'next/headers';
dotenv.config()

function CustomHead() {
  return (
    <Head>
      <title>Freemind</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </Head>
  );
}

export default function Home() {

  return (
    <section>
        <CustomHead />

        { cookies().has('token')? <Dashboard /> : <LoginForm /> }
    </section>
  );
}