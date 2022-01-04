import { useQuery } from "@apollo/client";
import {
  Avatar,
  Box,
  Button,
  Icon,
  Image,
  Menu,
  MenuButton,
  MenuItem,
  MenuList,
  useStyleConfig,
} from "@chakra-ui/react";
import React, { Fragment } from "react";
import { FaChevronDown, FaHome } from "react-icons/fa";

import { GET_ALL_ROOMS } from "../../../api/rooms";
import { Query, QueryRoomsArgs, Room, RoomConnection } from "../../../types";

export const NavbarRoomMenu = () => {
  const styles = useStyleConfig("NavbarButton");
  const { data: { rooms } = {} } = useQuery<
    Pick<Query, "rooms">,
    QueryRoomsArgs
  >(GET_ALL_ROOMS);

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
        {rooms!.edges!.map((room) => (
          <MenuItem key={room!.node!.slug}>
            <Avatar
              size="sm"
              name={room!.node!.name}
              src={room!.node!.avatarUrl!}
              mr="12px"
            />
            <span>{room!.node!.name}</span>
          </MenuItem>
        ))}
      </MenuList>
    </Menu>
  );
};
