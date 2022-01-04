import { ApolloProvider } from "@apollo/client";
import { ChakraProvider } from "@chakra-ui/react";
import { AppProps } from "next/app";
import Head from "next/head";
import { SessionProvider } from "next-auth/react";

import { Auth } from "../components";
import { useApollo } from "../lib/apollo";
import theme from "../theme";

function MyApp({
  Component,
  pageProps: { session, initialApolloState, ...pageProps },
}: AppProps) {
  const client = useApollo(initialApolloState);

  return (
    <ChakraProvider resetCSS theme={theme}>
      <ApolloProvider client={client}>
        <SessionProvider session={session}>
          <Head>
            <meta
              name="viewport"
              content="initial-scale=1.0, width=device-width"
            />
            <title>PlayRoom | Aula de Software Libre</title>
          </Head>
          <Auth>
            <Component {...pageProps} />
          </Auth>
        </SessionProvider>
      </ApolloProvider>
    </ChakraProvider>
  );
}

export default MyApp;
