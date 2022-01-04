import { Box, Link, Text } from "@chakra-ui/react";
import { useRouter } from "next/dist/client/router";
import React from "react";

import { Error } from "../..";

export const NotFoundError = () => {
  const router = useRouter();

  return (
    <Error code={404} title="Página no encontrada">
      <Text>
        Compruebe la dirección o{" "}
        <Link onClick={() => router.back()}>vuelva a la página anterior</Link>.
      </Text>
    </Error>
  );
};

export default NotFoundError;
