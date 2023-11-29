package com.sboot.controller;

import com.sboot.model.Categories;
import com.sboot.service.CategoriesService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;
import org.springframework.http.ResponseEntity;
import org.springframework.http.HttpStatus;


import java.util.List;
import java.util.Optional;
import java.util.ArrayList;

@CrossOrigin(origins = "*")
@RestController
@RequestMapping(path = "categories")
public class CategoriesController {

    @Autowired
    private CategoriesService categoriesService;


    @GetMapping
	public ResponseEntity<List<Categories>> getAllCategories() {
		try {
			List<Categories> categories = new ArrayList<Categories>();
			categoriesService.getCategories().forEach(categories::add);
			return new ResponseEntity<>(categories, HttpStatus.OK);
		} catch (Exception e) {
			return new ResponseEntity<>(HttpStatus.INTERNAL_SERVER_ERROR);
		}
	}

    @GetMapping("/{categoryId}")
	public ResponseEntity<Categories> getcategoryById(@PathVariable("categoryId") long id) {
		Optional<Categories> categoryData = categoriesService.getCategory(id);

		if (categoryData.isPresent()) {
			return new ResponseEntity<>(categoryData.get(), HttpStatus.OK);
		} else {
			return new ResponseEntity<>(HttpStatus.NOT_FOUND);
		}
	}
}