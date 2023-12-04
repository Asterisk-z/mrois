import React, { useState, createContext, useContext, useEffect } from 'react';

const UserContext = createContext();
const UserUpdateContext = createContext();


export function useUser(){
    return useContext(UserContext);
}

export function useUserUpdate(){
  return useContext(UserUpdateContext);
}


const UserProvider = ({...props}) => {
    const user_data = atob(localStorage.getItem('logger'));
    const json_user = JSON.parse(user_data)
    
    const defaultUser = {
      role: localStorage.getItem('role'), 
      id: localStorage.getItem('id'), 
      email: localStorage.getItem('user_mail'),
      firstName: localStorage.getItem('firstName'),
      user_data: json_user,
    }
    
    const [user, setUser] = useState(defaultUser);

    const userUpdate = {
      role : function(){
        setUser({...user, role : localStorage.getItem('role')})
      },
      id : function(){
        setUser({...user, id : localStorage.getItem('id')})
      },
      email : function(){
        setUser({...user, email : localStorage.getItem('user_mail')})
      },
      firstName : function(){
        setUser({...user, firstName : localStorage.getItem('firstName')})
      },
      user_data : function(){
        setUser({...user, user_data : JSON.parse(atob(localStorage.getItem('logger')))})
      },
      reset : function(e){
        setUser({...user, role : defaultUser.role, id: defaultUser.id, email: defaultUser.email, firstName: defaultUser.firstName })
      },
    }

  return (
    <UserContext.Provider value={user} >
      <UserUpdateContext.Provider value={userUpdate}>
        {props.children}
      </UserUpdateContext.Provider>
    </UserContext.Provider>
  )

}
export default UserProvider;