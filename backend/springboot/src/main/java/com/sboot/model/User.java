package com.sboot.model;

import jakarta.persistence.*;;

@Entity
@Table(name = "users")
public class User {

  @Id
  @GeneratedValue(strategy = GenerationType.IDENTITY)
  private long id;

  @Column(name = "username")
  private String username;

  @Column(name = "password")
  private String password;

  @Column(name = "email")
  private String email;

  @Column(name = "type_user")
  private String type = "client";

  @Column(name = "is_active")
  private Boolean is_active = true;

  @Column(name = "RT")
  private String RT = "rt";

  @Column(name = "photo")
  private String photo =
    "https://upload.wikimedia.org/wikipedia/commons/thumb/3/3a/Cat03.jpg/1200px-Cat03.jpg";

  public long getId() {
    return id;
  }

  public String getUsername() {
    return username;
  }

  public String getPassword() {
    return password;
  }

  public String getEmail() {
    return email;
  }

  public String getType() {
    return type;
  }

  public Boolean getIs_active() {
    return is_active;
  }

  public String getPhoto() {
    return photo;
  }

  public String getRT() {
    return RT;
  }

  public void setUsername(String username) {
    this.username = username;
  }

  public void setPassword(String password) {
    this.password = password;
  }

  public void setEmail(String email) {
    this.email = email;
  }

  public void setType(String type) {
    this.type = type;
  }

  public void setIs_active(Boolean is_active) {
    this.is_active = is_active;
  }

  public void setPhoto(String photo) {
    this.photo = photo;
  }
  
  public void setRT(String RT) {
    this.RT = RT;
  }

  @Override
  public String toString() {
    return (
      "User [id=" +
      id +
      ", username=" +
      username +
      ", password=" +
      password +
      ", email=" +
      email +
      ", type=" +
      type +
      ", is_active=" +
      is_active +
      ", photo=" +
      photo +
      "]"
    );
  }
}
