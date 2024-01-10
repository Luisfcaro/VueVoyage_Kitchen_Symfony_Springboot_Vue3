package com.sboot.model;

import com.fasterxml.jackson.annotation.JsonIgnore;

import jakarta.persistence.*;

@Entity
@Table(name = "bookings")
public class Bookings {

  @Id
  @GeneratedValue(strategy = GenerationType.IDENTITY)
  @Column(name = "id")
  private Long id;

  @ManyToOne(fetch = FetchType.LAZY, optional = false)
  @JoinColumn(name = "id_user", nullable = false)
  @JsonIgnore
  private User user;

  // @ManyToOne(fetch = FetchType.LAZY)
  @ManyToOne
  @JoinColumn(name = "id_rest")
  // @JsonIgnore
  private Restaurants restaurant;

  @ManyToOne(fetch = FetchType.LAZY, optional = false)
  @JoinColumn(name = "id_turn", nullable = false)
  @JsonIgnore
  private Turns turns;

  @Column(name = "people")
  private Integer people;

  @Column(name = "state")
  private String state;

  @Column(name = "date")
  private String date;

  public Bookings() {}

  public Bookings(Restaurants restaurant, Integer p, String st, String d) {
    this.restaurant = restaurant;
    this.people = p;
    this.state = st;
    this.date = d;
  }

  public Long getId() {
    return id;
  }

  public void setId(Long id) {
    this.id = id;
  }

  public User getUser() {
    return user;
  }

  public void setUser(User user) {
    this.user = user;
  }

  public Restaurants getRestaurant() {
    return this.restaurant;
  }

  public void setRestaurant(Restaurants restaurant) {
    this.restaurant = restaurant;
  }

  public Turns getTurns() {
    return turns;
  }

  public void setTurns(Turns turns) {
    this.turns = turns;
  }

  public Integer getPeople() {
    return people;
  }

  public void setPeople(Integer people) {
    this.people = people;
  }

  public String getState() {
    return state;
  }

  public void setState(String state) {
    this.state = state;
  }

  public String getDate() {
    return date;
  }

  public void setDate(String date) {
    this.date = date;
  }

  @Override
  public String toString() {
    return (
      "Bookings [id=" +
      id +
      ", user=" +
      user +
      ", restaurant=" +
      restaurant +
      ", turns=" +
      turns +
      ", people=" +
      people +
      ", state=" +
      state +
      ", date=" +
      date +
      "]"
    );
  }
}
