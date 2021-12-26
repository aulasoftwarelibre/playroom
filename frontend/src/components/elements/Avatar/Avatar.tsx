/* eslint-disable @next/next/no-img-element */
import getConfig from "next/config";
import React from "react";
import { Avatar as UiAvatar, AvatarBadge, AvatarGroup } from '@chakra-ui/react'
import {useSession} from "next-auth/react";

export const Avatar = () => {
  const { publicRuntimeConfig } = getConfig();
  const { data: session } = useSession();
  const user = session?.user!;

  if (!user.image) {
    return <UiAvatar size="sm" name={user.name!} />
  }

  return <UiAvatar size="sm" name={user.name!} src={`${publicRuntimeConfig.cdn}${user.image}`} />
};

export default Avatar;
