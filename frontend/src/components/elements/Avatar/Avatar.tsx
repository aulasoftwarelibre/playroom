/* eslint-disable @next/next/no-img-element */
import { Avatar as UiAvatar, AvatarBadge, AvatarGroup } from "@chakra-ui/react";
import getConfig from "next/config";
import { useSession } from "next-auth/react";
import React from "react";

export const Avatar = () => {
  const { publicRuntimeConfig } = getConfig();
  const { data: session } = useSession();
  const user = session?.user!;

  if (!user.image) {
    return <UiAvatar size="sm" name={user.name!} />;
  }

  return (
    <UiAvatar
      size="sm"
      name={user.name!}
      src={`${publicRuntimeConfig.cdn}${user.image}`}
    />
  );
};

export default Avatar;
