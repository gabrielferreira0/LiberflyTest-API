<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;
use db;


class TransactionController extends Controller
{
    /**
     * index – Lista os dados da tabela
     * show – Mostra um item específico
     * create – Retorna a View para criar um item da tabela
     * store – Salva o novo item na tabela
     * edit – Retorna a View para edição do dado
     * update – Salva a atualização do dado
     * destroy – Remove o dado
     */


    /**
     * @OA\Get(
     *   path="/api/transactions",
     *   summary="list all transactions",
     *   description="Get list transactions information",
     *   operationId="transactionIndex",
     *   tags={"Transactions"},
     *   security={ {"bearerAuth": {}}},
     *   @OA\Response(
     *     response=200,
     *     description="Success"
     *   ),
     * @OA\Response(
     *     response=400,
     *     description="Token is Expired",
     *     @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Not authorized")
     *     )
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Token não fornecido",
     *     @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Not authorized")
     *     )
     *   )
     * )
     */


    public function index()
    {

        //retorna todas as transacoes
        $transactions = Transaction::get();

        return response()->json([
            "data" => $transactions
        ], 200);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * @OA\Post(
     * path="/api/transactions",
     * summary="Add transaction",
     * description="add transaction",
     * operationId="transactionStore",
     * tags={"Transactions"},
     * security={{"bearerAuth": {}}},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"description","category","type","price"},
     *       @OA\Property(property="description", type="string", format="text", example="Aluguel"),
     *       @OA\Property(property="category", type="string", format="text", example="Apartamento"),
     *       @OA\Property(property="type", type="string", format="text", example="saida"),
     *       @OA\Property(property="price", type="number", format="number", example="1100.00"),
     *    ),
     * ),
     * @OA\Response(
     *    response=422,
     *    description="incorrect data",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, Please try again")
     *        )
     *     )
     * )
     * */
    public function store(Request $request)
    {

        //Realiza o insert no banco de acordo com as validacoes
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'description' => 'required|string|min:6',
            'category' => 'required|string',
            'type' => 'required|string',
            'price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $transaction = Transaction::create([
            'description' => $request->description,
            "category" => $request->category,
            "type" => $request->type,
            "price" => $request->price,
            "user_id" => $user->id,
        ]);

        return response()->json([
            'message' => 'Transaction successfully registered',
            'transaction' => $transaction
        ], 201);

    }

    /**
     * @OA\Get(
     *     path="/api/transactions/{id}",
     *     summary="list transaction",
     *     description="Get transactions information by id",
     *     operationId="transactionShow",
     *     tags={"Transactions"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         description="ID of transaction",
     *         in="path",
     *         name="id",
     *         required=true,
     *         example="1",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Token is Expired",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Not authorized")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token não fornecido",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Not authorized")
     *         )
     *     )
     * )
     */

    public function show(string $id)
    {
        //retorna a transacao de acordo com ID
        $transaction = Transaction::where('id', $id)->get();

        return response()->json([
            "data" => $transaction
        ], 200);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
