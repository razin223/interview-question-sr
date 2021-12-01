@extends('layouts.app')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Products</h1>
</div>


<div class="card">
    <form action="" method="get" class="card-header">
        <div class="form-row justify-content-between">
            <div class="col-md-2">
                <input type="text" name="title" placeholder="Product Title" class="form-control" value="{{request()->input('title')}}">
            </div>
            <div class="col-md-2">
                <select name="variant" id="" class="form-control">
                    <option value="">(select)</option>
                    <?php
                    foreach (\App\Models\Variant::orderBy('title', 'asc')->get() as $varient) {
                        echo "<optgroup label='{$varient->title}'>";
                        foreach (\App\Models\ProductVariant::where('variant_id', $varient->id)->select('variant')->groupBy('variant')->orderBy('variant')->get() as $value) {
                            echo "<option value='{$value->variant}'";
                            echo request()->input('variant') == $value->variant ? "selected" : "";
                            echo ">{$value->variant}</option>";
                        }
                        echo "</optgroup>";
                    }
                    ?>
                </select>
            </div>

            <div class="col-md-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Price Range</span>
                    </div>
                    <input type="text" name="price_from" aria-label="First name" placeholder="From" class="form-control" value="{{request()->input('price_from')}}">
                    <input type="text" name="price_to" aria-label="Last name" placeholder="To" class="form-control" value="{{request()->input('price_to')}}">
                </div>
            </div>
            <div class="col-md-2">
                <input type="date" name="date" placeholder="Date" class="form-control">
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary float-right"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>



    <div class="card-body">
        <div class="table-response">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th width="250px">Description</th>
                        <th>Variant</th>
                        <th width="50px">Action</th>
                    </tr>
                </thead>

                <tbody>

                    <?php
                    if ($Product->count()) {
                        $Sl = ($Product->currentPage() - 1) * $Product->perPage();

                        foreach ($Product as $Data) {
                            $Sl++;
                            ?>

                            <tr>
                                <td>{{$Sl}}</td>
                                <td>{{$Data->title}} <br> Created at : {{$Data->created_at->diffForHumans()}}</td>
                                <td>{{$Data->description}}</td>
                                <td>
                                    <?php
                                    if ($Data->getProductVariantPrice != null) {
                                        foreach ($Data->getProductVariantPrice as $Varient) {
                                            ?>
                                            <dl class="row mb-0" style="height: 80px; overflow: hidden" id="variant">

                                                <dt class="col-sm-3 pb-0">
                                                    <?php
                                                    $Color = $Varient->getProductVarientOne;
                                                    $Size = $Varient->getProductVarientTwo;
                                                    $Shape = $Varient->getProductVarientThree;

                                                    if ($Color != null) {
                                                        echo $Color->variant;
                                                    }
                                                    if ($Size != null) {
                                                        echo " / " . $Size->variant;
                                                    }

                                                    if ($Shape != null) {
                                                        echo " / " . $Shape->variant;
                                                    }
                                                    ?>
                                                </dt>
                                                <dd class="col-sm-9">
                                                    <dl class="row mb-0">
                                                        <dt class="col-sm-4 pb-0">Price : {{ number_format($Varient->price,2) }}</dt>
                                                        <dd class="col-sm-8 pb-0">InStock : {{ number_format($Varient->stock,2) }}</dd>
                                                    </dl>
                                                </dd>
                                            </dl>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <button onclick="$('#variant').toggleClass('h-auto')" class="btn btn-sm btn-link">Show more</button>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('product.edit', $Data->id) }}" class="btn btn-success">Edit</a>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="5" class="text-center text-warning">No data found.</td>
                        </tr>
                        <?php
                    }
                    ?>

                </tbody>

            </table>
        </div>


    </div>

    <div class="card-footer">
        <div class="row justify-content-between">
            <div class="col-md-6">
                <?php
                if ($Product->count()) {
                    ?>
                    <p>Showing {{$Product->firstItem()}} to {{$Product->lastItem()}} out of {{$Product->total()}}</p>
                    <?php
                }
                ?>
            </div>
            <div class="col-md-2">
                <?php
                if ($Product->count()) {
                    ?>
                    {{ $Product->links() }}
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

@endsection
