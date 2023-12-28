package com.sboot.model;

import com.sboot.dto.UserDTO;

public class UserAndToken {

  private String token;
  private UserDTO user;

  public UserAndToken(String token, UserDTO user) {
    this.user = user;
    this.token = token;
  }

  public String getToken() {
    return token;
  }

  public void setToken(String token) {
    this.token = token;
  }

  public UserDTO getUser() {
    return user;
  }

  public void setUser(UserDTO user) {
    this.user = user;
  }

  @Override
  public String toString() {
    return "UserAndToken [token=" + token + ", user=" + user + "]";
  }
}
