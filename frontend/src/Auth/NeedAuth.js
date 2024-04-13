import { Navigate, useLocation } from "react-router-dom";

export default function NeedAuth(props) {
  let location = useLocation();
  const currentUser = sessionStorage.getItem("user");
  if (currentUser) {
    return props.children;
  } else {
    return <Navigate to="/login" state={{ from: location }} />;
  }
}
