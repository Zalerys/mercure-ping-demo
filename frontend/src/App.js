import { BrowserRouter, Routes, Route } from "react-router-dom";
import NeedAuth from "./Auth/NeedAuth";
import UserList from "./Component/UserList";
import Login from "./Auth/Login";
import UserProvider from "./Context/UserContext";
import ChatAll from "./Component/ChatAll";

function App() {
  return (
    <UserProvider>
      <BrowserRouter>
        <Routes>
          <Route
            path="/"
            element={
              <NeedAuth>
                <UserList />
              </NeedAuth>
            }
          />
          <Route
            path="/all"
            element={
              <NeedAuth>
                <ChatAll />
              </NeedAuth>
            }
          />

          <Route path="/login" element={<Login />} />
        </Routes>
      </BrowserRouter>
    </UserProvider>
  );
}

export default App;
