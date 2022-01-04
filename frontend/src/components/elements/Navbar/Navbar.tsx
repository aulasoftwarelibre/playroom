import { CloseIcon, HamburgerIcon } from "@chakra-ui/icons";
import {
  Box,
  Button,
  Container,
  Drawer,
  DrawerBody,
  DrawerCloseButton,
  DrawerContent,
  DrawerFooter,
  DrawerHeader,
  DrawerOverlay,
  Flex,
  HStack,
  IconButton,
  Input,
  List,
  ListItem,
  Text,
  useDisclosure,
  useStyleConfig,
} from "@chakra-ui/react";
import React from "react";

import { DarkModeSwitch } from "../DarkModeSwitch";
import { NavbarAvatarMenu } from "./NavbarAvatarMenu";
import { NavbarRoomMenu } from "./NavbarRoomMenu";
import NavbarSearchBox from "./NavbarSearchBox";

export const Navbar = () => {
  const styles = useStyleConfig("Navbar");
  const { isOpen, onOpen, onClose } = useDisclosure();

  return (
    <>
      <Box zIndex="10" py="4" shadow="sm" sx={styles}>
        <Container
          maxWidth="container.xl"
          experimental_spaceX="4"
          display="flex"
          alignItems="center"
          px="6"
          mx="auto"
          justifyContent="space-between"
        >
          <IconButton
            size={"md"}
            icon={isOpen ? <CloseIcon /> : <HamburgerIcon />}
            aria-label={"Open Menu"}
            display={{ md: "none" }}
            onClick={isOpen ? onClose : onOpen}
          />
          <Flex flex="0 1 auto">
            <Text fontSize="lg" fontWeight="bold">
              PlayRoom
            </Text>
          </Flex>
          <HStack display={{ base: "none", md: "flex" }} flex="1 1 0%">
            <NavbarRoomMenu />
            <NavbarSearchBox />
          </HStack>
          <List display="flex" alignItems="center" experimental_spaceX="3">
            <ListItem>
              <DarkModeSwitch />
            </ListItem>
            <ListItem>
              <NavbarAvatarMenu />
            </ListItem>
          </List>
        </Container>
      </Box>
      <Drawer isOpen={isOpen} placement="right" onClose={onClose}>
        <DrawerOverlay />
        <DrawerContent>
          <DrawerCloseButton />
          <DrawerHeader>Create your account</DrawerHeader>

          <DrawerBody>
            <Input placeholder="Type here..." />
          </DrawerBody>

          <DrawerFooter>
            <Button variant="outline" mr={3} onClick={onClose}>
              Cancel
            </Button>
            <Button colorScheme="blue">Save</Button>
          </DrawerFooter>
        </DrawerContent>
      </Drawer>
    </>
  );
};

export default Navbar;
