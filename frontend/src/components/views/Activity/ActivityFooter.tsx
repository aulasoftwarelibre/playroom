import { Avatar, AvatarGroup, Box, Button, Flex, Icon } from "@chakra-ui/react";
import React from "react";
import { RiHeart2Fill, RiHeart2Line } from "react-icons/ri";

export const ActivityFooter = () => {
  return (
    <Flex
      alignItems="center"
      experimental_spaceX="5"
      fontSize="sm"
      pl="4"
      pb="2"
    >
      <Button
        rounded="full"
        fontSize="sm"
        px="3"
        fontWeight="normal"
        leftIcon={<Icon w="5" h="5" as={RiHeart2Line} />}
      >
        Únete
      </Button>

      <Box display="inline-flex" alignItems="center">
        <AvatarGroup size="sm" spacing="-5" _hover={{ spacing: "3" }}>
          <Avatar
            name="John Doe"
            src="https://images.pexels.com/photos/2589653/pexels-photo-2589653.jpeg?auto=compress&cs=tinysrgb&h=650&w=940"
          />
          <Avatar
            name="Jenny Doe"
            src="https://images.pexels.com/photos/2955305/pexels-photo-2955305.jpeg?auto=compress&cs=tinysrgb&h=650&w=940"
          />
          <Avatar
            name="Jenny Doe"
            src="https://images.pexels.com/photos/2589653/pexels-photo-2589653.jpeg?auto=compress&cs=tinysrgb&h=650&w=940"
          />
        </AvatarGroup>
        <Box pl="1">23</Box>
      </Box>
    </Flex>
  );
};
