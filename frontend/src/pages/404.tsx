import { BasicLayout, NotFoundError } from "../components";

export default function Custom404() {
  return (
    <BasicLayout>
      <NotFoundError />
    </BasicLayout>
  );
}
