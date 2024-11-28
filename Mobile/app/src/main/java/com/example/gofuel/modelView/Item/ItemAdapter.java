package com.example.gofuel.modelView.Item;

import android.content.Context;
import android.text.Editable;
import android.text.TextWatcher;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.inputmethod.InputMethodManager;
import android.widget.BaseAdapter;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;

import com.example.gofuel.databinding.ItemItemsBinding;
import com.example.gofuel.model.station_item.StationItem;
import com.example.gofuel.util.callback.OnItemQtyChange;

import java.util.ArrayList;

public class ItemAdapter extends BaseAdapter {
    private ArrayList<StationItem> stationItems;
    private final Context context;
    private final OnItemQtyChange onItemQtyChange;

    public ItemAdapter(Context context, ArrayList<StationItem> stationItems, OnItemQtyChange onItemQtyChange) {
        this.context = context;
        this.stationItems = stationItems;
        this.onItemQtyChange = onItemQtyChange;
    }

    @Override
    public int getCount() {
        return stationItems.size();
    }

    @Override
    public Object getItem(int i) {
        return stationItems.get(i);
    }

    @Override
    public long getItemId(int i) {
        return stationItems.get(i).getId();
    }

    @Override
    public View getView(int position, @Nullable View convertView, @NonNull ViewGroup parent) {
        ItemItemsBinding binding;
        ItemStationItemViewModel viewModel;

        if (convertView == null) {
            binding = ItemItemsBinding.inflate((LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE));
            convertView = binding.getRoot();
            viewModel = new ItemStationItemViewModel(binding);

            convertView.setTag(viewModel);
        } else {
            viewModel = (ItemStationItemViewModel) convertView.getTag();
            binding = viewModel.getItem();
        }

        viewModel.update(stationItems.get(position));

        //region Item Qty Change
        binding.itemQty.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence charSequence, int i, int i1, int i2) {

            }

            @Override
            public void onTextChanged(CharSequence charSequence, int i, int i1, int i2) {

            }

            @Override
            public void afterTextChanged(Editable editable) {
                if (!(editable.toString().isEmpty()) && !(editable.toString().equalsIgnoreCase("0"))) {
                    binding.itemQty.clearFocus();
                    ((InputMethodManager) context.getSystemService(Context.INPUT_METHOD_SERVICE)).hideSoftInputFromWindow(binding.itemQty.getWindowToken(), 0);
                    onItemQtyChange.onQtyChanged(true);
                }
                else {
                    onItemQtyChange.onQtyChanged(false);
                }
            }
        });
        //endregion

        //region Add Qty
        binding.addBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                int qty = Integer.parseInt(binding.itemQty.getText().toString());
                qty++;
                binding.itemQty.setText(String.valueOf(qty));
            }
        });
        //endregion

        //region Remove Qty
        binding.removeBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                int qty = Integer.parseInt(binding.itemQty.getText().toString());
                qty--;
                binding.itemQty.setText(String.valueOf(qty));
            }
        });
        //endregion

        return convertView;
    }
}
