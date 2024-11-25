package com.example.gofuel.view.fragments;

import android.os.Bundle;

import androidx.fragment.app.Fragment;
import androidx.lifecycle.ViewModelProvider;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.example.gofuel.R;
import com.example.gofuel.databinding.FragmentMainBinding;
import com.example.gofuel.model.client_station.ClientStation;
import com.example.gofuel.model.invoice.finished.FinishedInvoice;
import com.example.gofuel.model.invoice.pending.PendingInvoice;
import com.example.gofuel.modelView.Invoice.InvoiceAdapter;
import com.example.gofuel.modelView.Main.MainViewModel;
import com.example.gofuel.modelView.Main.adapters.ClientStationAdapter;
import com.example.gofuel.modelView.Main.adapters.FinishedInvoiceAdapter;
import com.example.gofuel.modelView.Main.adapters.PendingInvoiceAdapter;
import com.example.gofuel.util.State;

import java.util.ArrayList;
import java.util.HashMap;

public class MainFragment extends Fragment {

    private FragmentMainBinding binding;
    private MainViewModel viewModel;

    public MainFragment() {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        binding = FragmentMainBinding.inflate(inflater, container, false);
        View view = binding.getRoot();

        viewModel = new ViewModelProvider(this).get(MainViewModel.class);

        viewModel.getState().observe(getViewLifecycleOwner(), state -> {
            if (state instanceof State.Loading) {
                binding.favoriteStation.setVisibility(View.GONE);
                binding.pendingInvoices.setVisibility(View.GONE);
                binding.finishedInvoices.setVisibility(View.GONE);
                binding.loading.setVisibility(View.VISIBLE);
            }
            else if (state instanceof State.MainResults) {
                binding.loading.setVisibility(View.GONE);
                binding.favoriteStation.setVisibility(View.VISIBLE);
                binding.pendingInvoices.setVisibility(View.VISIBLE);
                binding.finishedInvoices.setVisibility(View.VISIBLE);

                ArrayList<ClientStation> favoriteStation = new ArrayList<>(((State.MainResults) state).getFavoriteStation());
                HashMap<String, String> pendingInvoices = new HashMap<>(((State.MainResults) state).getPendingInvoices());
                ArrayList<FinishedInvoice> finishedInvoices = new ArrayList<>(((State.MainResults) state).getFinishedInvoices());

                binding.favoriteStation.setAdapter(new ClientStationAdapter(getContext(), favoriteStation));
                binding.pendingInvoices.setAdapter(new PendingInvoiceAdapter(getContext(), pendingInvoices));
                binding.finishedInvoices.setAdapter(new FinishedInvoiceAdapter(getContext(), finishedInvoices));
            }
        });

        viewModel.loadInfo();

        return view;
    }
}