package com.sboot.service;

import com.sboot.model.Categories;
import com.sboot.repository.CategoriesRepository;

import jakarta.persistence.EntityNotFoundException;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.Optional;

@Service
public class CategoriesService {
    @Autowired
    CategoriesRepository categoriesRepository;

    public List<Categories> getCategories(){
        return categoriesRepository.findAll();
    }

    public Optional<Categories> getCategory(Long id){
        return categoriesRepository.findById(id);
    }
}