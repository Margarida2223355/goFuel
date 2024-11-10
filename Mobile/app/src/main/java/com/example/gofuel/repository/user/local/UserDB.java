package com.example.gofuel.repository.user.local;

import androidx.room.Dao;
import androidx.room.Insert;
import androidx.room.Query;

import com.example.gofuel.model.user.User;

import java.util.List;

@Dao
public interface UserDB {
    @Insert
    void addUser(User user);
    
    @Query("SELECT * FROM users")
    List<User> getAllUsers();

    @Query("DELETE FROM users")
    void deleteAll();
}
