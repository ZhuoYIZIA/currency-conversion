# Currency Conversion
版本資訊：<br>
Laravel : 9<br>
PHP     : 8<br>
此 project 為實作匯率轉換，
使用 Repository Pattern and Service Layer 進行實作，
Controller 只需要負責與 Service 溝通，其他事情交給 Service 做即可，
Repository 則負責存放 Model 取資料的邏輯。

## API
- [GET] api/conversion 轉換匯率 API

## Validator
負責驗證 request 的值。
- App\Http\Requests\CurrencyConversionRequest
    - 驗證 from   欄位 required|string
    - 驗證 to     欄位 required|string
    - 驗證 amount 欄位 required|integer

## Services
負責取得、轉換匯率，以及輸出的格式。
- App\Services\CurrencyConversionService
    - [method] convert - 轉換匯率
    - [method] format  - 轉換格式
- App\Services\ExchangeRateService
    - [method] getRatio - 取得匯率

## Repositories
負責資料庫溝通。

## Exception
Service 或 Repository 可以丟出特定的 exception，最後在 Controller 進行 try catch。
- App\Exceptions\ConversionExcaption

## Trait
使用 App\Trait\ResponseTrait 來統一回傳的格式，格式範例為以下：
```json
{
    "status"  : true,
    "message" : "some message",
    "data"    : {}
}
```

## Tests
測試 API 時將 getRatio mock 起來，避免取得匯率問題影響測試（假設獲取來源為第三方），
並且使用 dataProvider 將 API 的各種錯誤測試過一次。
- tests\Feature\ConversionTest
- tests\Unit\CurrencyConversionTest
