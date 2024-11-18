package com.example.gofuel.repository.item;


import com.example.gofuel.model.item.Item;
import com.example.gofuel.model.pump.Pump;
import com.example.gofuel.repository.common.ResultWrapper;

import java.util.List;

public interface IItemDataSource {
    interface Common {}

    // Remote data source
    interface Remote {
        ResultWrapper<List<Item>> getItems();
    }

    // Local data source
    interface Local {
        ResultWrapper<Item> getCachedItem();
    }

    interface Main extends Remote, Local {}
}
