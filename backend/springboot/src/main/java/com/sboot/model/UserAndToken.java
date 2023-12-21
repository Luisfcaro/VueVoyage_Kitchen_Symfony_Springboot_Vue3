package com.sboot.model;

public class UserAndToken {

  private String token;
  private User user;

  public UserAndToken(String token, User user) {
    this.user = user;
    this.token = token;
  }

  public String getToken() {
    return token;
  }

  public void setToken(String token) {
    this.token = token;
  }

  public User getUser() {
    return user;
  }

  public void setUser(User user) {
    this.user = user;
  }

  @Override
  public String toString() {
    return "UserAndToken [token=" + token + ", user=" + user + "]";
  }
}
