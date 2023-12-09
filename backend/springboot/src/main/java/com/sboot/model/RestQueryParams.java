package com.sboot.model;

import lombok.AllArgsConstructor;
import lombok.Getter;
import lombok.NoArgsConstructor;
import lombok.Setter;

@Getter
@Setter
@NoArgsConstructor
@AllArgsConstructor
public class RestQueryParams {
    private String[] categories;
    private Integer order;
    private String name_rest;
    private Integer page;
    private Integer limit;
}