import { useRouter } from "next/dist/client/router";
import React from "react";

import { Error } from "../.."
import {Box, Link, Text} from "@chakra-ui/react";

export const ServerError = () => {
  const router = useRouter();

  return (
    <Error code={500} title="Error del servidor">
      <Text>
      Puede {" "}
        <Link onClick={() => router.back()}>
          volver a la página anterior
        </Link>
      . Si el error persiste avise a los administradores.
      </Text>
    </Error>
  );
};

export default ServerError;
