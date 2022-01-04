import { Flex, Spinner } from "@chakra-ui/react";
import { useSession } from "next-auth/react";
import React from "react";
import { ImSpinner2 } from "react-icons/im";

import { BasicLayout } from "../../elements";

export const Auth: React.FunctionComponent = ({ children }) => {
  const { status } = useSession();

  if (status === "loading") {
    return (
      <BasicLayout>
        <Flex flexDirection="column" alignItems="center" w="100%">
          <Spinner as={ImSpinner2} size="xl" thickness="none" speed="1s" />
        </Flex>
      </BasicLayout>
    );
  }

  return <>{children}</>;
};

export default Auth;
