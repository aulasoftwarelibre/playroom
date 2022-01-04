export type Maybe<T> = T | null;
export type InputMaybe<T> = Maybe<T>;
export type Exact<T extends { [key: string]: unknown }> = {
  [K in keyof T]: T[K];
};
export type MakeOptional<T, K extends keyof T> = Omit<T, K> & {
  [SubKey in K]?: Maybe<T[SubKey]>;
};
export type MakeMaybe<T, K extends keyof T> = Omit<T, K> & {
  [SubKey in K]: Maybe<T[SubKey]>;
};
/** All built-in and custom scalars, mapped to their actual values */
export type Scalars = {
  ID: string;
  String: string;
  Boolean: boolean;
  Int: number;
  Float: number;
};

/** A node, according to the Relay specification. */
export type Node = {
  /** The id of this node. */
  id: Scalars["ID"];
};

export type Query = {
  __typename?: "Query";
  node?: Maybe<Node>;
  room?: Maybe<Room>;
  rooms?: Maybe<RoomConnection>;
};

export type QueryNodeArgs = {
  id: Scalars["ID"];
};

export type QueryRoomArgs = {
  id: Scalars["ID"];
};

export type QueryRoomsArgs = {
  after?: InputMaybe<Scalars["String"]>;
  before?: InputMaybe<Scalars["String"]>;
  first?: InputMaybe<Scalars["Int"]>;
  last?: InputMaybe<Scalars["Int"]>;
  order?: InputMaybe<Array<InputMaybe<RoomFilter_Order>>>;
};

export type Room = Node & {
  __typename?: "Room";
  avatarUrl?: Maybe<Scalars["String"]>;
  description: Scalars["String"];
  id: Scalars["ID"];
  imageUrl?: Maybe<Scalars["String"]>;
  name: Scalars["String"];
  slug: Scalars["String"];
};

/** Connection for Room. */
export type RoomConnection = {
  __typename?: "RoomConnection";
  edges?: Maybe<Array<Maybe<RoomEdge>>>;
  pageInfo: RoomPageInfo;
  totalCount: Scalars["Int"];
};

/** Edge of Room. */
export type RoomEdge = {
  __typename?: "RoomEdge";
  cursor: Scalars["String"];
  node?: Maybe<Room>;
};

export type RoomFilter_Order = {
  name?: InputMaybe<Scalars["String"]>;
};

/** Information about the current page. */
export type RoomPageInfo = {
  __typename?: "RoomPageInfo";
  endCursor?: Maybe<Scalars["String"]>;
  hasNextPage: Scalars["Boolean"];
  hasPreviousPage: Scalars["Boolean"];
  startCursor?: Maybe<Scalars["String"]>;
};
