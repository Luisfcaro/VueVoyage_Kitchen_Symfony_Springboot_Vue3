package com.sboot.dto;

import com.sboot.model.User;

import lombok.AllArgsConstructor;
import lombok.Getter;
import lombok.NoArgsConstructor;
import lombok.Setter;


@Getter
@Setter
@NoArgsConstructor
@AllArgsConstructor
public class UserDTO {

  private long id;
  private String username;
  private String email;
  private String type;
  private Boolean is_active;
  private String photo;

  public UserDTO(User user) {
    this.id = user.getId();
    this.username = user.getUsername();
    this.email = user.getEmail();
    this.type = user.getType();
    this.is_active = user.getIs_active();
    this.photo = user.getPhoto();
  }
}
