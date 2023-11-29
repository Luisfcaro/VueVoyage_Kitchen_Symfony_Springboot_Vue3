package com.sboot.model;

import jakarta.persistence.*;
import com.fasterxml.jackson.annotation.JsonIgnore;


@Entity
@Table(name = "Tables")
public class Tables {

  @Id
  @GeneratedValue(strategy = GenerationType.AUTO)
  @Column(name = "id_table")
  private Long id;

  @Column(name = "num_table")
  private Integer number;

  @Column(name = "capacity_table")
  private Integer capacity;

  @Column(name = "status_table")
  private String status;

  @ManyToOne(fetch = FetchType.LAZY)
  @JoinColumn(name = "id_rest")
  @MapsId("id_rest")
  @JsonIgnore
  private Restaurants restaurant;



  public Tables() {

  }

  public Tables(Integer number, Integer capacity, String status) {
    this.number = number;
    this.capacity = capacity;
    this.status = status;
  }

  public Long getId() {
      return this.id;
  }

  public void setId(Long id) {
      this.id = id;
  }

  public Integer getNumber() {
      return this.number;
  }

  public void setNumber(Integer number) {
      this.number = number;
  }

  public Integer getCapacity() {
      return this.capacity;
  }

  public void setCapacity(Integer capacity) {
      this.capacity = capacity;
  }

  public String getStatus() {
      return this.status;
  }

  public void setStatus(String status) {
      this.status = status;
  }

  public Restaurants getRestaurant() {
      return this.restaurant;
  }

  public void setRestaurant(Restaurants restaurant) {
      this.restaurant = restaurant;
  }

  @Override
  public String toString() {
      return "Tables [id=" + id + ", number=" + number + ", capacity=" + capacity + ", status=" + status + ", restaurant=" + restaurant + "]";
  }

}