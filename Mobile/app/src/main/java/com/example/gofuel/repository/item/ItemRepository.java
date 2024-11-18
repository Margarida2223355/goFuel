package com.example.gofuel.repository.item;

import android.content.Context;

import com.example.gofuel.model.item.Item;
import com.example.gofuel.repository.common.AppDatabase;
import com.example.gofuel.repository.common.ResultWrapper;
import com.example.gofuel.repository.item.local.ItemDB;
import com.example.gofuel.repository.item.remote.ItemRemoteDataSource;

import java.util.List;

public class ItemRepository implements IItemDataSource.Main {
    private static ItemRepository instance;
    private final ItemDB itemDB;

    private ItemRepository(Context context) {
        AppDatabase db = AppDatabase.getDatabase(context);
        itemDB = db.itemDB();
    }

    public static ItemRepository getInstance(Context context) {
        if (instance == null) {
            instance = new ItemRepository(context);
        }

        return instance;
    }

    @Override
    public ResultWrapper<Item> getCachedItem() {
        return null;
    }

    @Override
    public ResultWrapper<List<Item>> getItems() {
        ResultWrapper<List<Item>> result = new ItemRemoteDataSource().getItems();

        if (result.getResult() != null) {
            itemDB.deleteAll();
            itemDB.addAll(result.getResult());
        }
        else {
            // If there's data on local DB, return it
            if(!itemDB.getAllItems().isEmpty()) { result = new ResultWrapper <>(itemDB.getAllItems(), null); }

            // If there's no data on local DB, return an Error
            else { result = new ResultWrapper<>(null, "No data on local DB"); }
        }

        return result;
    }
}
