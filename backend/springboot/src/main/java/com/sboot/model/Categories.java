package com.sboot.model;

import jakarta.persistence.*;
import java.util.List;
import java.util.Set;
import java.util.HashSet;
import com.sboot.model.Restaurants;

import com.fasterxml.jackson.annotation.JsonIgnore;

@Entity
@Table(name = "Categories")
public class Categories {

  @Id
  @GeneratedValue(strategy = GenerationType.AUTO)
  @Column(name = "id")
  private Long id;

  @Column(name = "name_cat")
  private String name;

  @Column(name = "img_cat")
  private String img;

  @ManyToMany(fetch = FetchType.LAZY, cascade = { CascadeType.PERSIST, CascadeType.MERGE }, mappedBy = "categories")
  @JsonIgnore
  private Set<Restaurants> restaurants = new HashSet<>();



  public Categories() {

  }

  public Categories(String name, String img) {
    this.name = name;
    this.img = img;
  }

  public Set<Restaurants> getRestaurants() {
      return this.restaurants;
  }

  public Long getId() {
    return id;
  }

  public String getName() {
    return name;
  }

  public String getImg() {
    return img;
  }

  public void setRestaurants(Set<Restaurants> restaurants) {
      this.restaurants = restaurants;
  }

  public void setId(Long id) {
    this.id = id;
  }

  public void setName(String name) {
    this.name = name;
  }

  @Override
  public String toString() {
      return "Categories [id=" + id + ", name=" + name + ", img=" + img + ", restaurants=" + restaurants + "]";
  }

}