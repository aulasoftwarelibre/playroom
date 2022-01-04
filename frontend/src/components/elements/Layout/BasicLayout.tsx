import { Box, Container, Flex, useColorMode } from "@chakra-ui/react";
import React from "react";

export const BasicLayout: React.FunctionComponent = ({ children }) => {
  const { colorMode } = useColorMode();

  return (
    <Flex h="100vh" bgColor={`skin.${colorMode}.bg.body`}>
      <Box m="auto">
        <Container>{children}</Container>
      </Box>
    </Flex>
  );
};

export default BasicLayout;
