import { SearchIcon } from "@chakra-ui/icons";
import {
  Box,
  Input,
  InputGroup,
  InputLeftElement,
  useStyleConfig,
} from "@chakra-ui/react";
import React from "react";

export const NavbarSearchBox = () => {
  const styles = useStyleConfig("NavbarSearchBox");

  return (
    <Box flex="1 1 0%">
      <InputGroup w="full" maxW="container.xl">
        <InputLeftElement
          fontSize="sm"
          pointerEvents="none"
        >
          <SearchIcon color="gray.300" />
        </InputLeftElement>
        <Input
          fontSize="sm"
          placeholder="Buscar actividades"
          border="0"
          mr="100px"
          sx={styles}
        />
      </InputGroup>
    </Box>
  );
};

export default NavbarSearchBox;
