import { gql } from "@apollo/react-hooks";

import { RoomConnection } from "../types";

export const GET_ALL_ROOMS = gql(`
query GET_ALL_ROOMS {
  rooms(order: {name: "ASC"}) {
    edges {
      node {
        id
        name
        slug
        description
        avatarUrl
        imageUrl
      }
    }
  }
}
`);
