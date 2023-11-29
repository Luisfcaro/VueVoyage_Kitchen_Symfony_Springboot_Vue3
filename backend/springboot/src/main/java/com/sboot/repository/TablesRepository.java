package com.sboot.repository;

import com.sboot.model.Tables;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface TablesRepository extends JpaRepository<Tables, Long> {
}