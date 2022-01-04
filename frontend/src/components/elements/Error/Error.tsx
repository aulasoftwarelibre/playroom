import { Flex, Heading, Icon, Text } from "@chakra-ui/react";
import React from "react";

interface Props {
  code: number;
  title: string;
}

export const Error: React.FunctionComponent<Props> = ({
  code,
  title,
  children,
}) => {
  return (
    <Flex flexDirection="column" alignItems="center" px={6} mx="auto">
      <Heading fontSize="9xl" fontWeight="semibold">
        {code}
      </Heading>
      <Heading fontSize={{ base: "xl", md: "3xl" }} fontWeight="semibold">
        {title}
      </Heading>
      <Text mt={6}>{children}</Text>
    </Flex>
  );
};

export default Error;
