import { useRouter } from "next/dist/client/router";
import React from "react";

import { Error } from "../.."
import {Box, Link, Text} from "@chakra-ui/react";

export const UnauthorizedError = () => {
  const router = useRouter();

  return (
    <Error code={401} title="No autorizado">
      <Text>
        Para ver esta página necesita{" "}
        <Link onClick={() => router.push("/api/auth/signin")}>
          iniciar sesión
        </Link>
        .
      </Text>
    </Error>
  );
};

export default UnauthorizedError;
