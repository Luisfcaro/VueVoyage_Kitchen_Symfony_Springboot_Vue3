package com.sboot.model;

import jakarta.persistence.*;
import lombok.Data;

@Data
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
}