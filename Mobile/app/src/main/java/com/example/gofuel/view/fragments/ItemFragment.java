package com.example.gofuel.view.fragments;

import android.app.AlertDialog;
import android.os.Bundle;
import android.text.Editable;
import android.text.TextWatcher;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;

import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.Fragment;
import androidx.lifecycle.ViewModelProvider;

import com.example.gofuel.MyApplication;
import com.example.gofuel.R;
import com.example.gofuel.databinding.FragmentItemBinding;
import com.example.gofuel.databinding.InvoicesPopupBinding;
import com.example.gofuel.model.invoice.Invoice;
import com.example.gofuel.model.invoice.InvoicePost;
import com.example.gofuel.model.invoice.InvoiceStationPost;
import com.example.gofuel.model.invoice.invoiceline.InvoiceLine;
import com.example.gofuel.model.invoice.invoiceline.InvoicelinePost;
import com.example.gofuel.model.invoice.pending.PendingInvoice;
import com.example.gofuel.model.station.Station;
import com.example.gofuel.model.station_item.StationItem;
import com.example.gofuel.modelView.Invoice.InvoiceViewModel;
import com.example.gofuel.modelView.Invoiceline.InvoicelineViewModel;
import com.example.gofuel.modelView.Item.ItemAdapter;
import com.example.gofuel.modelView.Item.ItemStationItemViewModel;
import com.example.gofuel.modelView.Item.ItemViewModel;
import com.example.gofuel.util.State;
import com.example.gofuel.util.callback.InvoiceCreate;
import com.example.gofuel.util.callback.OnItemQtyChange;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.stream.Collectors;

public class ItemFragment extends Fragment {
    private FragmentItemBinding binding;
    private InvoicesPopupBinding popup;
    private Station station;
    private ItemViewModel viewModel;
    private InvoiceViewModel invoiceViewModel;
    private InvoicelineViewModel invoicelineViewModel;
    private HashMap<StationItem, Integer> cardItems;
    private PendingInvoice pendingInvoice;

    public ItemFragment() {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        binding = FragmentItemBinding.inflate(inflater, container, false);
        View view = binding.getRoot();

        viewModel = new ViewModelProvider(this).get(ItemViewModel.class);
        invoiceViewModel = new ViewModelProvider(this).get(InvoiceViewModel.class);
        invoicelineViewModel = new InvoicelineViewModel();
        cardItems = new HashMap<>();

        viewModel.getState().observe(getViewLifecycleOwner(), state -> {
            if (state instanceof State.Loading) {
                binding.itemList.setVisibility(View.GONE);
                binding.emptyState.setVisibility(View.GONE);
                binding.noInternet.setVisibility(View.GONE);
                binding.loading.setVisibility(View.VISIBLE);
            } else if (state instanceof State.StationItemList) {
                binding.loading.setVisibility(View.GONE);
                binding.emptyState.setVisibility(View.GONE);
                binding.noInternet.setVisibility(View.GONE);
                binding.itemList.setVisibility(View.VISIBLE);
                HashMap<StationItem, Integer> stationItems = new HashMap<>(((State.StationItemList) state).getStationItems());

                binding.itemList.setAdapter(new ItemAdapter(getContext(), stationItems, new OnItemQtyChange() {
                    @Override
                    public void onQtyChanged(Boolean show) {
                        if (show) {
                            binding.cardButton.setVisibility(View.VISIBLE);
                        } else {
                            binding.cardButton.setVisibility(View.GONE);
                        }
                    }

                    @Override
                    public void changeQty(StationItem item, int qty) {
                        viewModel.updateItemsQty(item, qty);
                    }

                    @Override
                    public void onUpdateQty(InvoiceLine line) {}
                }));

                //Disable list clicks
                binding.itemList.setEnabled(false);
            } else if (state instanceof State.EmptyState) {
                binding.itemList.setVisibility(View.GONE);
                binding.loading.setVisibility(View.GONE);
                binding.noInternet.setVisibility(View.GONE);
                binding.emptyState.setVisibility(View.VISIBLE);
            } else if (state instanceof State.NoInternet) {
                binding.itemList.setVisibility(View.GONE);
                binding.loading.setVisibility(View.GONE);
                binding.emptyState.setVisibility(View.GONE);
                binding.noInternet.setVisibility(View.VISIBLE);
            }
        });

        viewModel.loadItems(station);

        //region On card button click
        binding.cardButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                popup = InvoicesPopupBinding.inflate(inflater, container, false);
                view = popup.getRoot();

                for (int i = 0; i < binding.itemList.getCount(); i++) {
                    ItemStationItemViewModel itemViewModel = (ItemStationItemViewModel) binding.itemList.getChildAt(i).getTag();
                    cardItems.put(itemViewModel.getStationItem(), Integer.valueOf(itemViewModel.getItem().itemQty.getText().toString()));
                }

                showInvoicesPopup();
            }
        });
        //endregion

        //region Search for Category/Description
        binding.searchText.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence charSequence, int i, int i1, int i2) {

            }

            @Override
            public void onTextChanged(CharSequence charSequence, int i, int i1, int i2) {

            }

            @Override
            public void afterTextChanged(Editable editable) {
                viewModel.getItemsByCategoryDescription(editable.toString());
            }
        });
        //endregion

        //region Clear search text
        binding.clearIcon.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                binding.searchText.clearFocus();
                binding.searchText.setText("");
            }
        });
        //endregion

        return view;
    }

    public void setStation(Station station) {
        this.station = station;
    }

    private void showInvoicesPopup() {
        InvoicesPopupBinding popup = InvoicesPopupBinding.inflate(LayoutInflater.from(getContext()));

        AlertDialog dialog = new AlertDialog.Builder(getContext())
                .setView(popup.getRoot())
                .setCancelable(true)
                .create();

        invoiceViewModel.getState().observe(getViewLifecycleOwner(), state -> {
            if (state instanceof State.PendingInvoiceList) {
                List<PendingInvoice> invoices = new ArrayList<>(((State.PendingInvoiceList) state).getInvoices());
                List<String> codes = invoices.stream().map(PendingInvoice::getCode).collect(Collectors.toList());
                codes.add("Nova Fatura");

                popup.invoiceList.setAdapter(new ArrayAdapter<>(
                        getContext(),
                        R.layout.simple_item,
                        codes
                ));

                popup.invoiceList.setOnItemClickListener((parent, view, position, id) -> {
                    CartFragment cartFragment = new CartFragment();

                    if (position == (codes.size() - 1)) {
                        invoiceViewModel.createInvoice(new InvoicePost(MyApplication.getUser().getId(), station.getId()), new InvoiceCreate() {
                            @Override
                            public void onSuccess(PendingInvoice pendingInvoice) {
                                cartFragment.setInvoice(pendingInvoice);
                                addItemsToInvoice(pendingInvoice);

                                dialog.dismiss();

                                AppCompatActivity activity = (AppCompatActivity) view.getContext();
                                activity.getSupportFragmentManager()
                                        .beginTransaction()
                                        .replace(R.id.fragment, cartFragment)
                                        .addToBackStack(null)
                                        .commit();
                            }

                            @Override
                            public void onError(String error) {
                                Log.e("-->", "Error: " + error);
                            }
                        });
                    }
                    else {
                        cartFragment.setInvoice(invoices.get(position));
                        addItemsToInvoice(invoices.get(position));

                        dialog.dismiss();

                        AppCompatActivity activity = (AppCompatActivity) view.getContext();
                        activity.getSupportFragmentManager()
                                .beginTransaction()
                                .replace(R.id.fragment, cartFragment)
                                .addToBackStack(null)
                                .commit();
                    }
                });

                dialog.show();
            }
            else if (state instanceof State.EmptyState) {
                List<String> codes = new ArrayList<>();
                codes.add("Nova Fatura");

                popup.invoiceList.setAdapter(new ArrayAdapter<>(
                        getContext(),
                        R.layout.simple_item,
                        codes
                ));

                popup.invoiceList.setOnItemClickListener((parent, view, position, id) -> {
                    CartFragment cartFragment = new CartFragment();

                    if (position == (codes.size() - 1)) {
                        invoiceViewModel.createInvoice(new InvoicePost(MyApplication.getUser().getId(), station.getId()), new InvoiceCreate() {
                            @Override
                            public void onSuccess(PendingInvoice pendingInvoice) {
                                cartFragment.setInvoice(pendingInvoice);
                                addItemsToInvoice(pendingInvoice);

                                dialog.dismiss();

                                AppCompatActivity activity = (AppCompatActivity) view.getContext();
                                activity.getSupportFragmentManager()
                                        .beginTransaction()
                                        .replace(R.id.fragment, cartFragment)
                                        .addToBackStack(null)
                                        .commit();
                            }

                            @Override
                            public void onError(String error) {
                                Log.e("-->", "Error: " + error);
                            }
                        });
                    }
                });

                dialog.show();
            }
        });

        invoiceViewModel.loadPendingStationInvoices(new InvoiceStationPost(MyApplication.getUser().getId(), station.getId()));
    }

    private void addItemsToInvoice(PendingInvoice invoice) {
        List<InvoicelinePost> invoices = new ArrayList<>();

        for (Map.Entry<StationItem, Integer> item : cardItems.entrySet()) {
            if (item.getValue() != 0) {
                invoices.add(
                    new InvoicelinePost(
                        item.getKey().getItem().getId(),
                        item.getValue(),
                        (float) (item.getValue() * item.getKey().getPrice()),
                        invoice.getId()
                    )
                );
            }
        }

        invoicelineViewModel.addLines(invoices, invoice);
    }
}