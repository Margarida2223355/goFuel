package com.example.gofuel.repository.user;

import com.example.gofuel.model.user.User;
import com.example.gofuel.repository.common.ResultWrapper;

public interface IUserDataSource {
    interface Common {}

    // Remote data source
    interface Remote {
        ResultWrapper<User> loginUser(String username, String password);
        ResultWrapper<User> getUser();
    }

    // Local data source
    interface Local {
        ResultWrapper<User> getCachedUser();
    }

    interface Main extends IUserDataSource.Remote, IUserDataSource.Local {}
}
