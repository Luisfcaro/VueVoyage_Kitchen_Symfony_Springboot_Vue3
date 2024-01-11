package com.sboot.model;

import jakarta.persistence.*;
import java.util.HashSet;
import java.util.List;
import java.util.Set;

// import lombok.Data;

// @Data
@Entity
@Table(name = "Restaurant")
public class Restaurants {

  @Id
  @GeneratedValue(strategy = GenerationType.AUTO)
  @Column(name = "id")
  private Long id;

  @Column(name = "name_rest")
  private String name;

  @Column(name = "img_rest")
  private String img;

  @Column(name = "location_rest")
  private String location;

  @ManyToMany(
    fetch = FetchType.LAZY,
    cascade = { CascadeType.PERSIST, CascadeType.MERGE }
  )
  @JoinTable(
    name = "restaurant_category",
    joinColumns = { @JoinColumn(name = "restaurant_id") },
    inverseJoinColumns = { @JoinColumn(name = "category_id") }
  )
  // @JsonIgnore
  private Set<Categories> categories = new HashSet<>();

  @OneToMany(mappedBy = "restaurant", cascade = CascadeType.ALL)
  private List<Tables> tables;

  public Restaurants() {}

  public Restaurants(String name, String img, String location) {
    this.name = name;
    this.img = img;
    this.location = location;
  }

  public Set<Categories> getCategories() {
    return this.categories;
  }

  public void setCategories(Set<Categories> categories) {
    this.categories = categories;
  }

  public List<Tables> getTables() {
    return this.tables;
  }

  public void setTables(List<Tables> tables) {
    this.tables = tables;
  }

  public Long getId() {
    return id;
  }

  public String getname() {
    return name;
  }

  public void setname(String name) {
    this.name = name;
  }

  public String getimg() {
    return img;
  }

  public void setimg(String img) {
    this.img = img;
  }

  public String getlocation() {
    return location;
  }

  public void setlocation(String location) {
    this.location = location;
  }

  @Override
  public String toString() {
    return (
      "Restaurants: [id_rest=" +
      id +
      ", name_rest=" +
      name +
      ", img=" +
      img +
      ", location=" +
      location +
      ", categories=" +
      categories +
      ", tables=" +
      tables +
      "]"
    );
  }
}
