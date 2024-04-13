import { useLocation, useNavigate } from "react-router-dom";
import { useContext, useState } from "react";
import { userContext } from "../Context/UserContext";
import useGetJWT from "../Hook/useGetJWT";

export default function Login() {
  const navigate = useNavigate();
  let location = useLocation();
  let from = location.state?.from?.pathname || "/";

  const getJWT = useGetJWT();
  const [username, setUsername] = useState("");
  const [password, setPassword] = useState("");
  const [loggedUser, setLoggedUser] = useContext(userContext);

  const handleUsername = (e) => {
    setUsername(capitalizeFirstLetter(e.target.value));
  };

  const handlePassword = (e) => {
    setPassword(e.target.value);
  };

  const capitalizeFirstLetter = (str) => {
    return str.charAt(0).toUpperCase() + str.slice(1);
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    getJWT(username, password).then((data) => {
      if (data.JWT) {
        setLoggedUser(data.JWT);
        sessionStorage.setItem("user", username);
        sessionStorage.setItem("id", data.userId);
        navigate(from, { replace: true });
      }
    });
  };

  return (
    <div className="flex justify-center items-center h-screen bg-slate-100">
      <form
        className="flex flex-col justify-around bg-white shadow-md rounded-sm px-8 pt-8 pb-8 w-1/4 h-1/3 mb-4"
        onSubmit={handleSubmit}
      >
        <h1 className="mb-2 text-md text-sky-800 text-center font-semibold ">
          Login
        </h1>
        <div className="flex flex-col mb-3">
          <label className="text-sm mb-1" htmlFor="username">
            Username
          </label>
          <input
            type="text"
            className="pl-1 py-2 bg-slate-100"
            id="username"
            onChange={handleUsername}
            value={username}
          />
        </div>
        <div className="mb-3 flex flex-col">
          <label className="text-sm mb-1" htmlFor="password">
            Password
          </label>
          <input
            className="py-2 pl-1 mb-2 bg-slate-100"
            type="password"
            id="password"
            onChange={handlePassword}
            value={password}
            placeholder="**********"
          />
        </div>
        <button
          className="text-white bg-sky-800 w-32 mx-auto rounded-md p-2"
          type="submit"
        >
          Se connecter
        </button>
      </form>
    </div>
  );
}
