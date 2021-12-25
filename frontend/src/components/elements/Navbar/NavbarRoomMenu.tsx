import {
  Box,
  Button,
  Icon,
  Menu,
  MenuButton,
  MenuItem,
  MenuList,
  useStyleConfig,
} from "@chakra-ui/react";
import React, { Fragment } from "react";
import { FaChevronDown, FaHome } from "react-icons/fa";

export const NavbarRoomMenu = () => {
  const styles = useStyleConfig("NavbarButton");

  return (
    <Menu isLazy>
      <MenuButton
        w="64"
        display="inline-flex"
        justifyContent="space-between"
        sx={styles}
        as={Button}
      >
        <Box display="inline-flex" justifyContent="space-between" w="full">
          <Box display="inline-flex">
            <Icon as={FaHome} ml="-1" mr="2" />
            Principal
          </Box>
          <Icon as={FaChevronDown} mr="-1" />
        </Box>
      </MenuButton>
      <MenuList w="64">
        <MenuItem>Opción 1</MenuItem>
        <MenuItem>Opción 2</MenuItem>
        <MenuItem>Opción 3</MenuItem>
      </MenuList>
    </Menu>
  );
};
