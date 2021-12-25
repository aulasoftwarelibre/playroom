import { useRouter } from "next/dist/client/router";
import React from "react";

import { Error } from "../.."
import {Box, Link, Text} from "@chakra-ui/react";

export const ForbiddenError = () => {
  const router = useRouter();

  return (
    <Error code={403} title="Permiso denegado">
      <Text>
        No está autorizado para ver esta página. Compruebe la dirección  o{" "}
        <Link onClick={() => router.back()}>
          vuelva a la página anterior
        </Link>
      .
      </Text>
    </Error>
  );
};

export default ForbiddenError;
