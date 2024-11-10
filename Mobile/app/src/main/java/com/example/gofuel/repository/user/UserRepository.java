package com.example.gofuel.repository.user;

import android.content.Context;

import com.example.gofuel.model.user.User;
import com.example.gofuel.repository.common.AppDatabase;
import com.example.gofuel.repository.common.ResultWrapper;
import com.example.gofuel.repository.user.local.UserDB;
import com.example.gofuel.repository.user.remote.UserRemoteDataSource;

public class UserRepository implements IUserDataSource.Main {
    private static UserRepository instance;
    private final UserDB userDB;

    private UserRepository(Context context) {
        AppDatabase db = AppDatabase.getDatabase(context);
        userDB = db.userDB();
    }

    public static UserRepository getInstance(Context context) {
        if (instance == null) {
            instance = new UserRepository(context);
        }

        return instance;
    }

    @Override
    public ResultWrapper<User> getCachedUser() {
        return null;
    }

    @Override
    public ResultWrapper<User> loginUser(String username, String password) {
        ResultWrapper<User> result = new UserRemoteDataSource(username, password).getUser();

        if (result.getResult() != null) {
            userDB.deleteAll();
            userDB.addUser(result.getResult());
        }

        else {
            result = new ResultWrapper<>(null, "Username/Password incorrect!");
        }

        return result;
    }

    @Override
    public ResultWrapper<User> getUser() {
        return null;
    }
}
