import { BasicLayout, ServerError } from "../components";

export default function Custom500() {
  return (
    <BasicLayout>
      <ServerError />
    </BasicLayout>
  );
}
