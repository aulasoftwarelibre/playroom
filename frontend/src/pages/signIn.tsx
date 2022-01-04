/* eslint-disable @next/next/no-img-element */
import {
  Box,
  Button,
  Flex,
  Heading,
  Image,
  useColorMode,
  useMultiStyleConfig,
  useStyleConfig,
} from "@chakra-ui/react";
import { NextPageContext } from "next";
import Head from "next/head";
import { Provider } from "next-auth/providers";
import { getCsrfToken, getProviders, signIn } from "next-auth/react";
import React from "react";

import { DarkModeSwitch } from "../components";

interface Props {
  providers: any;
  csrfToken: any;
}

export default function SignIn({ providers, csrfToken }: Props) {
  const [email, setEmail] = React.useState<string>();
  const providersToRender = Object.values<Provider>(providers);
  const { colorMode } = useColorMode();

  return (
    <>
      <Head>
        <title>Iniciar sesión | PlayRoom</title>
      </Head>
      <Flex
        minH="100vh"
        alignItems="center"
        p={6}
        bgColor={`skin.${colorMode}.bg.body`}
      >
        <Flex
          flex="1 1 0%"
          h="100%"
          maxW="4xl"
          mx="auto"
          overflow="hidden"
          bgColor={`skin.${colorMode}.bg.base`}
          rounded="lg"
          shadow="lg"
        >
          <Flex
            position="relative"
            flexDirection={{ base: "column", md: "row" }}
            overflowY="auto"
            w="100%"
          >
            <Box h={{ base: 32, md: "auto" }} w={{ md: "50%" }}>
              <Image
                alt="Banner"
                aria-hidden
                objectFit="cover"
                width="100%"
                height="100%"
                src="/assets/img/banner.png"
              />
            </Box>
            <Flex
              alignItems="center"
              justifyItems="center"
              p={{ base: 6, sm: 12 }}
              w={{ md: "50%" }}
            >
              <Box w="100%">
                <Heading mb={4} fontSize="xl" fontWeight="semibold">
                  Iniciar sesión
                </Heading>

                {providersToRender.map((provider, i) => (
                  <div key={provider.id}>
                    {provider.type === "oauth" && (
                      <Button
                        variant="login"
                        key={provider.name}
                        onClick={() =>
                          signIn(provider.id, { callbackUrl: "/" })
                        }
                      >
                        {provider.name}
                      </Button>
                    )}

                    {provider.type === "email" && (
                      <div className="mt-4 px-4 py-3 mb-8 bg border border-skin-base shadow-md bg-skin-accent">
                        <input
                          name="csrfToken"
                          type="hidden"
                          defaultValue={csrfToken}
                        />

                        <label
                          className="block text-sm"
                          htmlFor={`input-email-for-${provider.id}-provider`}
                        >
                          <span className="text-skin-base">Email</span>
                          <input
                            className="block w-full mt-1 text-sm bg-skin-accent border-skin-accent focus:border-skin-primary focus:outline-none text-skin-base form-input"
                            data-test="email"
                            id={`input-email-for-${provider.id}-provider`}
                            name="email"
                            type="email"
                            value={email}
                            onChange={(e) => setEmail(e.target.value)}
                          />
                        </label>

                        <div className="block text-sm mt-4">
                          <Button
                            data-test="submit-signin"
                            type="submit"
                            onClick={() => signIn("email", { email })}
                          >
                            Comprobar
                          </Button>
                        </div>
                      </div>
                    )}
                  </div>
                ))}
              </Box>
            </Flex>
            <div className="absolute top-4 right-4 text-skin-base">
              <DarkModeSwitch />
            </div>
          </Flex>
        </Flex>
      </Flex>
    </>
  );
}

export async function getServerSideProps(context: NextPageContext) {
  const providers = await getProviders();
  const csrfToken = await getCsrfToken(context);
  return {
    props: { providers, csrfToken },
  };
}
