import { ChakraProvider } from "@chakra-ui/react";
import { AppProps } from "next/app";
import Head from "next/head";
import { SessionProvider } from "next-auth/react"

import theme from "../theme";
import {Auth} from "../components";

function MyApp({Component, pageProps: { session, ...pageProps }}: AppProps
) {
  return (
    <ChakraProvider resetCSS theme={theme}>
      <SessionProvider session={session}>
        <Head>
          <meta name="viewport" content="initial-scale=1.0, width=device-width" />
          <title>PlayRoom | Aula de Software Libre</title>
        </Head>
        <Auth>
          <Component {...pageProps} />
        </Auth>
      </SessionProvider>
    </ChakraProvider>
  );
}

export default MyApp;
