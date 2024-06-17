/**
    * @description      :
    * @author           : BYLL JAKE
    * @group            :
    * @created          : 15/04/2023 - 17:42
    *
    * MODIFICATION LOG
    * - Version         : 1.0.0
    * - Date            : 21/10/2023
    * - Author          : BYLL jake
    * - Modification    :
**/
import { TestBed } from '@angular/core/testing';

import { JwtInterceptor } from './jwt.interceptor';

describe('JwtInterceptor', () => {
  beforeEach(() => TestBed.configureTestingModule({
    providers: [
      JwtInterceptor
      ]
  }));

  it('should be created', () => {
    const interceptor: JwtInterceptor = TestBed.inject(JwtInterceptor);
    expect(interceptor).toBeTruthy();
  });
});
