package com.sboot.dto;

import lombok.Data;
import java.util.List;

@Data
public class RestaurantDTO {
    private String id_rest;
    private String name;
    private String img_restaurant;
    private String location;
    private List<CategoryDTO> categories;

}
