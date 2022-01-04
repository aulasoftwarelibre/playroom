import { Flex } from "@chakra-ui/layout";
import {
  Button,
  Menu,
  MenuButton,
  MenuItem,
  MenuList,
  Text,
  useStyleConfig,
} from "@chakra-ui/react";
import { useRouter } from "next/dist/client/router";
import { signOut, useSession } from "next-auth/react";
import React from "react";

import { Avatar } from "../Avatar";

export const NavbarAvatarMenu = () => {
  const styles = useStyleConfig("NavbarButton");
  const { data: session } = useSession();
  const router = useRouter();

  if (!session) {
    return (
      <Button variant="login" onClick={() => router.push("/signIn")}>
        Conectar
      </Button>
    );
  }

  return (
    <Flex alignItems="center">
      <Menu>
        <MenuButton
          as={Button}
          rounded="full"
          variant="link"
          cursor="pointer"
          minW="0"
          sx={styles}
        >
          <Avatar />
        </MenuButton>
        <MenuList>
          <MenuItem onClick={() => signOut()}>Cerrar sesión</MenuItem>
        </MenuList>
      </Menu>
    </Flex>
  );
};
